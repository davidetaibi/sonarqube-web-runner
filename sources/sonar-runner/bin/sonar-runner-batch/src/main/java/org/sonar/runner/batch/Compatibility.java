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

import org.sonar.batch.bootstrapper.Batch;
import org.sonar.batch.bootstrapper.LogOutput;

public class Compatibility {
  private Compatibility() {
    // Utility class
  }

  static void setLogOutputFor5dot2(Batch.Builder builder, final org.sonar.runner.batch.LogOutput logOutput) {
    builder.setLogOutput(new LogOutput() {

      @Override
      public void log(String formattedMessage, Level level) {
        logOutput.log(formattedMessage, org.sonar.runner.batch.LogOutput.Level.valueOf(level.name()));
      }

    });
  }

  static org.sonar.batch.bootstrapper.IssueListener getBatchIssueListener(IssueListener listener, boolean hasPreciseLocation) {
    return new IssueListenerAdapter(listener, hasPreciseLocation);
  }

  static class IssueListenerAdapter implements org.sonar.batch.bootstrapper.IssueListener {
    private IssueListener listener;
    private boolean hasPreciseLocation;

    public IssueListenerAdapter(IssueListener listener, boolean hasPreciseLocation) {
      this.listener = listener;
      this.hasPreciseLocation = hasPreciseLocation;
    }

    @Override
    public void handle(Issue issue) {
      listener.handle(transformIssue(issue));
    }

    private IssueListener.Issue transformIssue(Issue batchIssue) {
      IssueListener.Issue newIssue = new IssueListener.Issue();

      newIssue.setAssigneeLogin(batchIssue.getAssigneeLogin());
      newIssue.setAssigneeName(batchIssue.getAssigneeName());
      newIssue.setComponentKey(batchIssue.getComponentKey());
      newIssue.setKey(batchIssue.getKey());
      newIssue.setResolution(batchIssue.getResolution());
      newIssue.setRuleKey(batchIssue.getRuleKey());
      newIssue.setRuleName(batchIssue.getRuleName());
      newIssue.setMessage(batchIssue.getMessage());
      newIssue.setNew(batchIssue.isNew());
      newIssue.setSeverity(batchIssue.getSeverity());
      newIssue.setStatus(batchIssue.getStatus());

      if (hasPreciseLocation) {
        newIssue.setStartLine(batchIssue.getStartLine());
        newIssue.setStartLineOffset(batchIssue.getStartLineOffset());
        newIssue.setEndLine(batchIssue.getEndLine());
        newIssue.setEndLineOffset(batchIssue.getEndLineOffset());
      } else {
        newIssue.setStartLine(batchIssue.getLine());
        newIssue.setEndLine(batchIssue.getLine());
      }

      return newIssue;
    }
  }
}
