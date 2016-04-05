/*
 * SonarQube Runner - Batch
 * Copyright (C) 2011-2016 SonarSource SA
 * mailto:contact AT sonarsource DOT com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
package org.sonar.runner.batch;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.nio.charset.StandardCharsets;
import java.util.List;
import java.util.Map;
import java.util.Properties;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.sonar.batch.bootstrapper.Batch;

/**
 * This class is executed within the classloader provided by the server. It contains the installed plugins and
 * the same version of sonar-batch as the server.
 */
public class BatchIsolatedLauncher implements IsolatedLauncher {
  private static final String VERSION_FORMAT = "^(\\d+)\\.(\\d+)";
  private Batch batch = null;
  private final BatchFactory factory;
  private final Pattern versionPattern;

  public BatchIsolatedLauncher() {
    this(new DefaultBatchFactory());
  }

  public BatchIsolatedLauncher(BatchFactory factory) {
    this.factory = factory;
    this.versionPattern = Pattern.compile(VERSION_FORMAT);
  }

  @Override
  public void start(Properties globalProperties, org.sonar.runner.batch.LogOutput logOutput, boolean preferCache) {
    batch = factory.createBatch(globalProperties, logOutput, null);
    batch.start(preferCache);
  }

  @Override
  public void stop() {
    batch.stop();
  }

  @Override
  public void execute(Properties properties) {
    batch.executeTask((Map) properties);
  }

  @Override
  public void execute(Properties properties, IssueListener listener) {
    org.sonar.batch.bootstrapper.IssueListener batchIssueListener = Compatibility.getBatchIssueListener(listener, hasPreciseIssueLocation(getVersion()));
    batch.executeTask((Map) properties, batchIssueListener);
  }

  @Override
  public void syncProject(String projectKey) {
    batch.syncProject(projectKey);
  }

  /**
   * This method exists for backward compatibility with SonarQube &lt; 5.2. 
   */
  @Override
  public void executeOldVersion(Properties properties, List<Object> extensions) {
    factory.createBatch(properties, null, extensions).execute();
  }

  boolean hasPreciseIssueLocation(String version) {
    if (version == null) {
      return false;
    }

    Matcher matcher = versionPattern.matcher(version);
    if (!matcher.find() || matcher.groupCount() < 2) {
      return false;
    }

    Integer major = Integer.parseInt(matcher.group(1));
    Integer minor = Integer.parseInt(matcher.group(2));

    return major > 5 || (major == 5 && minor >= 3);
  }

  @Override
  public String getVersion() {
    InputStream is = this.getClass().getClassLoader().getResourceAsStream("sq-version.txt");
    if (is == null) {
      return null;
    }
    try (BufferedReader br = new BufferedReader(new InputStreamReader(is, StandardCharsets.UTF_8))) {
      return br.readLine();
    } catch (IOException e) {
      return null;
    }
  }
}
